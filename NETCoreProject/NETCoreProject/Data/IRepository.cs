using NETCoreProject.Models;
using System.Collections.Generic;
using System.Threading.Tasks;

namespace NETCoreProject.Data
{
    public interface IRepository<T> where T : class, IEntity
    {
        Task<List<T>> Get();
        Task<T> GetById();
        Task<T> Create(T entity);
        Task<T> Update(int id, T entity);
        Task<T> DeleteById(int id);
    }
}
