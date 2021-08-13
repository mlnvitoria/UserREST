using NETCoreProject.Models;
using System.Collections.Generic;
using System.Threading.Tasks;

namespace NETCoreProject.Data.Interfaces
{
    public interface IRepository<T> where T : class, IEntity
    {
        Task<T> GetById(int id);
        Task<T> Create(T entity);
        Task<T> Update(T entity);
        Task<T> DeleteById(int id);
    }
}
