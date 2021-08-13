using NETCoreProject.Models;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace NETCoreProject.Data.Interfaces
{
    public interface IUserRepository : IRepository<User>
    {
        public Task<User> FindByApiToken(string apiToken);
        public new Task<User> Create(User user);
    }
}
